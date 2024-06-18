<?php

namespace App\Providers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    /**
     * Generates a storage image for fixtures.
     *
     * @param string $fixturesDir The directory where fixtures are stored.
     * @param string $storageDir The directory where the storage image will be saved.
     * @return string The path to the stored image.
     */
    public function fixturesImage(string $fixturesDir, string $storageDir): string {
        if (!Storage::exists($storageDir)) {
            Storage::makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/$fixturesDir"),
            Storage::path($storageDir)
        );

        return '/storage/' . trim($storageDir, '/') . '/' . basename($file);
    }
}
