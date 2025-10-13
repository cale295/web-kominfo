<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => \App\Filters\Cors::class, // pastikan file Cors.php ada di App\Filters
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
    ];

    // kosongkan dulu supaya nggak bentrok
    public array $required = [
        'before' => [],
        'after'  => [],
    ];

    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [];

    public array $filters = [
        // Terapkan filter CORS ke semua endpoint API
        'cors' => [
            'before' => ['api/*'],
            'after'  => ['api/*'],
        ],
    ];
}