<?php

namespace App\Helpers;

class AppHelper
{
    public function __construct()
    {
        /**
         * todo
         * qui è possibile verificare se ci sono migrazioni da fare o azioni da eseguire
         */
    }

    /**
     * Funzione che genera il dropdown per le azioni di DataTable
     *
     * @param $elements
     * @param $icon
     *
     * @return string
     */
    public static function datatableActions($elements = [], $icon = 'icon')
    {
        $title = __("Actions");
        if ($icon == 'icon') {
            $title = '<i class="fas fa-bars fa-lg"></i>';
        }

        $return = '<div class="dropdown ">
                            <a href="#" class="dropdown-toggle list-icons-item" data-bs-toggle="dropdown" data-toggle="dropdown" aria-expanded="true">
                                ' . $title . '
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                ' . implode(' ', $elements) . '
                            </div>
                    </div>
                    ';
        return $return;
    }
}
