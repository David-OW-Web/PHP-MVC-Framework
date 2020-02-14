<?php

require 'config/config.php';
require 'core/Helper.php';

session_start();

Helper::Redirect('Home', 'Index');