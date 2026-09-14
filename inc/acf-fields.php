<?php
// Definicje pól ACF w kodzie (wersja darmowa — bez Repeatera i bez Options
// Page, ten sam ograniczony zestaw co na indoornavi.me). Repeatable listy
// (outcome/use_case/device_spec/control_feature/how_step/product_spec) mają
// pola przypięte przez location 'post_type' — patrz inc/cpts.php dla samych
// typów wpisów.
//
// Pola w kodzie (acf_add_local_field_group) zamiast w UI ACF-a: pojawiają
// się od razu, bez ręcznego klikania w wp-adminie, i żyją w repozytorium
// razem z resztą motywu.

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

add_action( 'acf/init', 'in_security_register_outcome_fields' );
function in_security_register_outcome_fields() {
    acf_add_local_field_group( [
        'key'    => 'group_outcome_content',
        'title'  => 'Treść kafla',
        'fields' => [
            [
                'key'     => 'field_outcome_icon',
                'label'   => 'Ikona',
                'name'    => 'icon',
                'type'    => 'select',
                'choices' => in_security_icon_choices(),
                'default_value' => 'check-circle',
            ],
            [ 'key' => 'field_outcome_tab_pl', 'label' => 'Polski', 'type' => 'tab' ],
            [ 'key' => 'field_outcome_title_pl', 'label' => 'Tytuł', 'name' => 'title_pl', 'type' => 'text' ],
            [ 'key' => 'field_outcome_content_pl', 'label' => 'Treść', 'name' => 'content_pl', 'type' => 'textarea', 'rows' => 3 ],
            [ 'key' => 'field_outcome_tab_en', 'label' => 'English', 'type' => 'tab' ],
            [ 'key' => 'field_outcome_title_en', 'label' => 'Title', 'name' => 'title_en', 'type' => 'text' ],
            [ 'key' => 'field_outcome_content_en', 'label' => 'Content', 'name' => 'content_en', 'type' => 'textarea', 'rows' => 3 ],
        ],
        'location' => [
            [
                [ 'param' => 'post_type', 'operator' => '==', 'value' => 'outcome' ],
            ],
        ],
    ] );
}

add_action( 'acf/init', 'in_security_register_use_case_fields' );
function in_security_register_use_case_fields() {
    acf_add_local_field_group( [
        'key'    => 'group_use_case_content',
        'title'  => 'Treść tagu',
        'fields' => [
            [ 'key' => 'field_use_case_tab_pl', 'label' => 'Polski', 'type' => 'tab' ],
            [ 'key' => 'field_use_case_label_pl', 'label' => 'Nazwa', 'name' => 'label_pl', 'type' => 'text' ],
            [ 'key' => 'field_use_case_tab_en', 'label' => 'English', 'type' => 'tab' ],
            [ 'key' => 'field_use_case_label_en', 'label' => 'Name', 'name' => 'label_en', 'type' => 'text' ],
        ],
        'location' => [
            [
                [ 'param' => 'post_type', 'operator' => '==', 'value' => 'use_case' ],
            ],
        ],
    ] );
}

add_action( 'acf/init', 'in_security_register_device_spec_fields' );
function in_security_register_device_spec_fields() {
    acf_add_local_field_group( [
        'key'    => 'group_device_spec_content',
        'title'  => 'Treść karty',
        'fields' => [
            [ 'key' => 'field_device_spec_tab_pl', 'label' => 'Polski', 'type' => 'tab' ],
            [ 'key' => 'field_device_spec_title_pl', 'label' => 'Tytuł', 'name' => 'title_pl', 'type' => 'text' ],
            [ 'key' => 'field_device_spec_content_pl', 'label' => 'Treść (dozwolony <strong>)', 'name' => 'content_pl', 'type' => 'textarea', 'rows' => 3 ],
            [ 'key' => 'field_device_spec_tab_en', 'label' => 'English', 'type' => 'tab' ],
            [ 'key' => 'field_device_spec_title_en', 'label' => 'Title', 'name' => 'title_en', 'type' => 'text' ],
            [ 'key' => 'field_device_spec_content_en', 'label' => 'Content (allows <strong>)', 'name' => 'content_en', 'type' => 'textarea', 'rows' => 3 ],
        ],
        'location' => [
            [
                [ 'param' => 'post_type', 'operator' => '==', 'value' => 'device_spec' ],
            ],
        ],
    ] );
}

add_action( 'acf/init', 'in_security_register_control_feature_fields' );
function in_security_register_control_feature_fields() {
    acf_add_local_field_group( [
        'key'    => 'group_control_feature_content',
        'title'  => 'Treść funkcji',
        'fields' => [
            [
                'key'   => 'field_control_feature_screenshot',
                'label' => 'Zrzut ekranu',
                'name'  => 'screenshot',
                'type'  => 'image',
                'return_format' => 'url',
            ],
            [ 'key' => 'field_control_feature_tab_pl', 'label' => 'Polski', 'type' => 'tab' ],
            [ 'key' => 'field_control_feature_tag_pl', 'label' => 'Etykieta (mały tag nad tytułem)', 'name' => 'tag_pl', 'type' => 'text' ],
            [ 'key' => 'field_control_feature_title_pl', 'label' => 'Tytuł', 'name' => 'title_pl', 'type' => 'text' ],
            [ 'key' => 'field_control_feature_content_pl', 'label' => 'Treść', 'name' => 'content_pl', 'type' => 'textarea', 'rows' => 3 ],
            [ 'key' => 'field_control_feature_tab_en', 'label' => 'English', 'type' => 'tab' ],
            [ 'key' => 'field_control_feature_tag_en', 'label' => 'Tag (small label above title)', 'name' => 'tag_en', 'type' => 'text' ],
            [ 'key' => 'field_control_feature_title_en', 'label' => 'Title', 'name' => 'title_en', 'type' => 'text' ],
            [ 'key' => 'field_control_feature_content_en', 'label' => 'Content', 'name' => 'content_en', 'type' => 'textarea', 'rows' => 3 ],
        ],
        'location' => [
            [
                [ 'param' => 'post_type', 'operator' => '==', 'value' => 'control_feature' ],
            ],
        ],
    ] );
}

add_action( 'acf/init', 'in_security_register_how_step_fields' );
function in_security_register_how_step_fields() {
    acf_add_local_field_group( [
        'key'    => 'group_how_step_content',
        'title'  => 'Treść kroku',
        'fields' => [
            [
                'key'     => 'field_how_step_icon',
                'label'   => 'Ikona',
                'name'    => 'icon',
                'type'    => 'select',
                'choices' => in_security_icon_choices(),
                'default_value' => 'pin',
            ],
            [ 'key' => 'field_how_step_tab_pl', 'label' => 'Polski', 'type' => 'tab' ],
            [ 'key' => 'field_how_step_title_pl', 'label' => 'Tytuł', 'name' => 'title_pl', 'type' => 'text' ],
            [ 'key' => 'field_how_step_content_pl', 'label' => 'Treść', 'name' => 'content_pl', 'type' => 'textarea', 'rows' => 2 ],
            [ 'key' => 'field_how_step_tab_en', 'label' => 'English', 'type' => 'tab' ],
            [ 'key' => 'field_how_step_title_en', 'label' => 'Title', 'name' => 'title_en', 'type' => 'text' ],
            [ 'key' => 'field_how_step_content_en', 'label' => 'Content', 'name' => 'content_en', 'type' => 'textarea', 'rows' => 2 ],
        ],
        'location' => [
            [
                [ 'param' => 'post_type', 'operator' => '==', 'value' => 'how_step' ],
            ],
        ],
    ] );
}

add_action( 'acf/init', 'in_security_register_product_spec_fields' );
function in_security_register_product_spec_fields() {
    acf_add_local_field_group( [
        'key'    => 'group_product_spec_content',
        'title'  => 'Treść wiersza',
        'fields' => [
            [
                'key'     => 'field_product_spec_product',
                'label'   => 'Produkt',
                'name'    => 'product',
                'type'    => 'select',
                'choices' => [
                    'in_guard' => 'IN Guard',
                    'in_sense' => 'IN Sense',
                ],
                'default_value' => 'in_guard',
            ],
            [ 'key' => 'field_product_spec_tab_pl', 'label' => 'Polski', 'type' => 'tab' ],
            [ 'key' => 'field_product_spec_label_pl', 'label' => 'Etykieta (lewa kolumna)', 'name' => 'label_pl', 'type' => 'text' ],
            [ 'key' => 'field_product_spec_value_pl', 'label' => 'Wartość (prawa kolumna)', 'name' => 'value_pl', 'type' => 'textarea', 'rows' => 2 ],
            [ 'key' => 'field_product_spec_tab_en', 'label' => 'English', 'type' => 'tab' ],
            [ 'key' => 'field_product_spec_label_en', 'label' => 'Label (left column)', 'name' => 'label_en', 'type' => 'text' ],
            [ 'key' => 'field_product_spec_value_en', 'label' => 'Value (right column)', 'name' => 'value_en', 'type' => 'textarea', 'rows' => 2 ],
        ],
        'location' => [
            [
                [ 'param' => 'post_type', 'operator' => '==', 'value' => 'product_spec' ],
            ],
        ],
    ] );
}
