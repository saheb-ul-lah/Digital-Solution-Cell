<?php
include 'form_template.php';

// Define the fields for your form
$fields = [
    ['label' => 'Menu Name', 'name' => 'menu_name', 'type' => 'text'],
    ['label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
    ['label' => 'Upload File', 'name' => 'file', 'type' => 'file'],
    ['label' => 'Category', 'name' => 'category', 'type' => 'dropdown', 'options' => ['Appetizer', 'Main Course', 'Dessert']],
    ['label' => 'Is Available?', 'name' => 'is_available', 'type' => 'radio', 'options' => ['Yes', 'No']]
];

// Render the form
render_form($fields, 'upload_menu.php');
?>
