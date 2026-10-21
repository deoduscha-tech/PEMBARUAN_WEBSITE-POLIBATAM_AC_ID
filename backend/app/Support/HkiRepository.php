<?php

namespace App\Support;

class HkiRepository
{
    public function all(): array
    {
        $path = resource_path('data/hki.php');
        $data = is_file($path) ? require $path : [];
        return is_array($data) ? $data : [];
    }

    public function save(array $data): void
    {
        $path = resource_path('data/hki.php');
        $contents = "<?php\n\n// HKI archive records managed from the admin workspace.\nreturn " . var_export($data, true) . ";\n";
        file_put_contents($path, $contents, LOCK_EX);
    }
}
