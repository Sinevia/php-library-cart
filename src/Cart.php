<?php

namespace Sinevia;

class Cart {

    protected $items = array();

    function __construct($options = array()) {
        $session = isset($options['session']) == false ? false : $options['session'];
        if ($session == true) {
            if (session_id() == '') {
                session_start();
            }
            if (isset($_SESSION['shopping_cart_items']) == false) {
                $_SESSION['shopping_cart_items'] = array();
            }
            $items = &$_SESSION['shopping_cart_items'];
        }
        $this->items = &$items;
    }

    function addItem($item) {
        $this->items[] = $item;
    }

    function emptyCart(){
        $this->items = array();
    }

    /**
     * Remove single item of a given ID from the cart
     */
    function removeItemByItemId($item_id) {
        $new_list = array();
        $is_removed = false;
        foreach ($this->items as $item) {
            if ($is_removed == false && $item['id'] == $item_id) {
                $is_removed = true;
                continue;
            }
            $new_list[] = $item;
        }
        $this->items = $new_list;
    }

    /**
     * Remove all items of a given ID from the cart
     */
    function removeItemsByItemId($item_id) {
        $new_list = array();
        foreach ($this->items as $item) {
            if ($item['id'] == $item_id) {
                continue;
            }
            $new_list[] = $item;
        }
        $this->items = $new_list;
    }

    /**
     * Get the total quantity of items in the cart
     */
    function getItemsCount() {
        return count($this->items);
    }

    /**
     * Get an array of unique item IDs in the cart
     */
    function getItems() {
        return $this->items;
    }

    /**
     * Get an array of unique item IDs in the cart
     */
    function getDistinctItems() {
        $distinct_items = array();
        foreach ($this->items as $item) {
            if (in_array($item, $distinct_items)) {
                continue;
            }
            $distinct_items[] = $item;
        }
        return $distinct_items;
    }

    /**
     * Get the quantity of an item in the cart for an ID
     */
    function getItemQuantityByItemId($item_id) {
        $quantity = 0;
        foreach ($this->items as $item) {
            if ($item['id'] == $item_id) {
                $quantity++;
            }
        }
        return $quantity;
    }

    /**
     * Get the per item price for an ID
     */
    function getItemPriceByItemId($item_id) {
        $price = 0;
        foreach ($this->items as $item) {
            if ($item['id'] == $item_id) {
                $price = $item['price'];
                break;
            }
        }
        return $price;
    }

    /**
     * Get the per item price for an ID
     */
    function getItemTotalPriceByItemId($item_id) {
        $price = 0;
        foreach ($this->items as $item) {
            if ($item['id'] == $item_id) {
                $price += $item['price'];
            }
        }
        return $price;
    }

    /**
     * Get the total price for the cart.
     */
    function getTotalPrice() {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item['price'];
        }
        return $price;
    }

}
