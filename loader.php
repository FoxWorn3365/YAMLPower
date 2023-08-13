<?php
function get(string $dir = "src") {
    foreach (glob("{$dir}/*") as $file) {
        if (is_dir($file)) {
            get($file);
        } else {
            include $file;
        }
    }
}
get();