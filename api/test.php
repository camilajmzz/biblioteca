<?php
require_once __DIR__ . '/phpqrcode/qrlib.php';

if(class_exists('QRcode')){
    echo "OK: QRcode existe";
} else {
    echo "ERROR: QRcode NO existe";
}
