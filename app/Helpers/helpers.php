<?php

if (!function_exists('render_product_section')) {
    function render_product_section(int $id): string
    {
        try {
            $section = \App\Models\HomeProductSection::find($id);
            if (!$section || !$section->is_active) return '';
            $products = $section->getProducts();
            if ($products->isEmpty()) return '';
            return view('frontend.components.product-section', [
                'section'  => $section,
                'products' => $products,
            ])->render();
        } catch (\Exception $e) {
            return '';
        }
    }
}