<?php
require 'monime_config.php';
if (defined('MONIME_TOKEN')) {
    echo "✅ Config is working! Token is set.";
} else {
    echo "❌ Config is NOT working. PHP cannot see the constants.";
}
?>