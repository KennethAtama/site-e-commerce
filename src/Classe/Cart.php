<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    /*
     * add()
     * function permettant l'ajout d'un produit au panier
     */
    public function add($product)
    {
        //appel session symfony
        $cart = $this->requestStack->getSession()->get('cart');

        // ajout d'une quantité à un produit
        if(isset($cart[$product->getId()])) {
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else {
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => 1
            ];
        }
        // creation session Cart
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
     * decrease()
     * function permettant la suppression d'une quantité d'un produit au panier
     */
    public function decrease($id)
    {
        $cart = $this->requestStack->getSession()->get('cart');

        if($cart[$id]['qty'] > 1) {
            $cart[$id]['qty'] = $cart[$id]['qty'] - 1;
        }
        else {
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
     * fullQuantity()
     * function retournant le nombre total de produits au panier
     */
    public function fullQuantity()
    {
        $cart = $this->requestStack->getSession()->get('cart');
        $quantity = 0;

        if(isset($cart)) {
            foreach ($cart as $product) {
                $quantity = $quantity + $product['qty'];
            }
        }

        return $quantity;
    }

    /*
     * getTotalWt()
     * Fonction retournant le prix des produits au panier
     */
    public function getTotalWt()
    {
        $cart = $this->requestStack->getSession()->get('cart');
        $price = 0;

        if(isset($cart)) {
            foreach ($cart as $product) {
                $price = $price + ($product['objet']->getPriceWt() * $product['qty']);
            }
        }
        return $price;
    }

    /*
     * remove()
     * Fonction permettant de supprimer totalement le panier
     */
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    /*
     * getCart()
     * Fonction retournant le panier
     */
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }

}
