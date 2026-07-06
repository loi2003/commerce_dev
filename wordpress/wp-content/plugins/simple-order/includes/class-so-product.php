<?php

class SO_Product
{
    public function get_products()
    {
        return wc_get_products([
            'limit' => 20,
            'status' => 'publish'
        ]);
    }

    public function get_product($id)
    {
        return wc_get_product($id);
    }
}