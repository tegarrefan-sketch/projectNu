<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfficerPhotoService
{
    /**
     * Process, resize, fix EXIF orientation, convert to WebP, and store an officer photo.
     *
     * @param UploadedFile $file
     * @param string|null $oldPath
     * @return string Relative path inside storage/app/public
     */
    public function processAndStore(UploadedFile $file, ?string $oldPath = null): string
    {
        // 1. Delete old photo if exists
        $this->deleteOld($oldPath);

        // 2. Prepare directory
        $disk = Storage::disk('public');
        $directory = 'officers';
        if (!$disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }

        $filename = Str::random(40) . '.webp';
        $relativeTarget = $directory . '/' . $filename;
        $absoluteTarget = $disk->path($relativeTarget);

        // 3. Check if GD extension is loaded
        if (!extension_loaded('gd') || !function_exists('imagewebp')) {
            Log::warning('GD extension or imagewebp function not available, storing original officer photo.');
            return $file->store($directory, 'public');
        }

        try {
            $sourcePath = $file->getRealPath();
            $mime = $file->getMimeType();

            // Create image resource based on mime type
            $sourceImage = null;
            if (in_array($mime, ['image/jpeg', 'image/jpg', 'image/pjpeg'])) {
                $sourceImage = @imagecreatefromjpeg($sourcePath);
            } elseif (in_array($mime, ['image/png', 'image/x-png'])) {
                $sourceImage = @imagecreatefrompng($sourcePath);
            } elseif (in_array($mime, ['image/webp'])) {
                $sourceImage = @imagecreatefromwebp($sourcePath);
            }

            if (!$sourceImage) {
                // Try string fallback
                $data = file_get_contents($sourcePath);
                $sourceImage = @imagecreatefromstring($data);
            }

            if (!$sourceImage) {
                Log::warning('Failed to create GD image resource, fallback to storing original officer photo.');
                return $file->store($directory, 'public');
            }

            // 4. Fix EXIF orientation (chiefly for JPEGs from smartphones)
            $sourceImage = $this->fixExifOrientation($sourceImage, $sourcePath, $mime);

            // 5. Calculate dimensions (max 800px on the longest side, never upscale)
            $width = imagesx($sourceImage);
            $height = imagesy($sourceImage);
            $maxDimension = 800;

            if ($width > $maxDimension || $height > $maxDimension) {
                if ($width >= $height) {
                    $newWidth = $maxDimension;
                    $newHeight = (int) round(($height / $width) * $maxDimension);
                } else {
                    $newHeight = $maxDimension;
                    $newWidth = (int) round(($width / $height) * $maxDimension);
                }
            } else {
                $newWidth = $width;
                $newHeight = $height;
            }

            // 6. Resample into destination canvas
            $targetImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve alpha transparency
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
            imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);

            imagecopyresampled(
                $targetImage,
                $sourceImage,
                0, 0, 0, 0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );

            // 7. Save as WebP with quality 80
            $success = imagewebp($targetImage, $absoluteTarget, 80);

            // Free GD memory
            imagedestroy($sourceImage);
            imagedestroy($targetImage);

            if (!$success || !file_exists($absoluteTarget)) {
                Log::warning('imagewebp returned false, storing original officer photo.');
                return $file->store($directory, 'public');
            }

            return $relativeTarget;
        } catch (\Throwable $e) {
            Log::error('Error processing officer photo: ' . $e->getMessage());
            return $file->store($directory, 'public');
        }
    }

    /**
     * Fix orientation based on EXIF data.
     */
    protected function fixExifOrientation($image, string $filePath, ?string $mime)
    {
        if (!function_exists('exif_read_data') || !in_array($mime, ['image/jpeg', 'image/jpg'])) {
            return $image;
        }

        try {
            $exif = @exif_read_data($filePath);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $rotated = imagerotate($image, 180, 0);
                        if ($rotated) {
                            imagedestroy($image);
                            return $rotated;
                        }
                        break;
                    case 6:
                        $rotated = imagerotate($image, -90, 0);
                        if ($rotated) {
                            imagedestroy($image);
                            return $rotated;
                        }
                        break;
                    case 8:
                        $rotated = imagerotate($image, 90, 0);
                        if ($rotated) {
                            imagedestroy($image);
                            return $rotated;
                        }
                        break;
                }
            }
        } catch (\Throwable $e) {
            // Ignore EXIF parsing issues
        }

        return $image;
    }

    /**
     * Delete an old photo from storage if it exists.
     */
    public function deleteOld(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
