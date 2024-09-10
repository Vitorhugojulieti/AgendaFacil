<?php
namespace app\classes;

require_once '../vendor/autoload.php';
// use MercadoPago\SDK;
// use MercadoPago\Client\PreferencePreference;
// use MercadoPago\Item;
use MercadoPago\Client\Preference\PreferenceClient as Preference;
use MercadoPago\Client\Preference\Item;

class MercadoPagoCheckout 
{
    private $preference;
    public function __construct()
    {
        // SDK::setAccessToken('APP_USR-755243105641278-081414-7bcf2e0f0dca37440db1731b6fa8bc93-292669619');
        $this->preference = new Preference();
    }

    /**
     * Configura os itens da preferência de pagamento.
     *
     * @param array $items Array de itens com título, quantidade e preço.
     */
    public function setItems(array $items)
    {
        $mercadoPagoItems = [];
        foreach ($items as $item) {
            $mercadoPagoItem = new Item();
            $mercadoPagoItem->title = $item['title'];
            $mercadoPagoItem->quantity = $item['quantity'];
            $mercadoPagoItem->unit_price = $item['unit_price'];
            $mercadoPagoItems[] = $mercadoPagoItem;
        }
        $this->preference->items = $mercadoPagoItems;
    }

    /**
     * Configura as URLs de retorno após o pagamento.
     *
     * @param string $successURL URL para redirecionamento em caso de sucesso.
     * @param string $failureURL URL para redirecionamento em caso de falha.
     * @param string $pendingURL URL para redirecionamento em caso de pendência.
     */
    public function setBackUrls($successURL, $failureURL, $pendingURL)
    {
        $this->preference->back_urls = array(
            "success" => $successURL,
            "failure" => $failureURL,
            "pending" => $pendingURL
        );
    }

    /**
     * Salva a preferência e retorna a URL do Checkout Bricks.
     *
     * @return string URL do Checkout Bricks.
     */
    public function generateBrickUrl()
    {
        $this->preference->save();
        return $this->preference->init_point;
    }
}