<?php

if (!function_exists('btn_toggle')) {
    /**
     * Membuat tombol toggle switch otomatis
     * * @param int|string $id ID dari item (misal: id_banner)
     * @param int|string $status Status saat ini (1 atau 0)
     * @param string $controllerUrl URL Controller (misal: 'banner/toggle-status')
     */
    function btn_toggle($id, $status, $controllerUrl)
    {
        $isActive = ($status == '1');
        $classActive = $isActive ? 'active' : '';
        $text = $isActive ? 'Aktif' : 'Non-Aktif';
        $fullUrl = site_url($controllerUrl);

        return "
        <button type='button' class='status-btn' 
                data-id='{$id}' 
                data-url='{$fullUrl}'>
            <div class='switch {$classActive}'></div>
            <span class='switch-label'>{$text}</span>
        </button>
        ";
    }
}