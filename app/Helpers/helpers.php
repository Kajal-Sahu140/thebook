<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('get_file_url')) {
    /**
     * Get the full URL of the given storage path.
     *
     * @param string $path
     * @return string
     */
    function get_file_url($path)
    {
        // Check if the path starts with 'storage/' and adjust accordingly
        if (strpos($path, 'storage/') !== false) {
            // This assumes the file is stored in the public disk under 'storage/'
            return url($path);
        }

        // If the path doesn't include 'storage/', prepend the necessary directory
        return url('storage/' . $path);
    }
}

