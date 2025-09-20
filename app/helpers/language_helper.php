<?php
// app/helpers/language_helper.php

function trans($key, $default = '') {
    return \App\Core\Language::get($key, $default);
}
