## Laravel Cart - Shopping cart management

Create and manage shopping carts in different namespaces

### Install

```shell
composer require masoudi/laravel-cart
```

```shell
php artisan vendor:publish --tag=laravel-cart
```

### How to use
implements model with `Payable` interface and add `InteractsWithCart` 
trait in model like below example:

```php
use Masoudi\Laravel\Cart\Contracts\Payable;
use Masoudi\Laravel\Cart\Support\Traits\InteractsWithCart;

class Product extends Model implements Payable
{
    use InteractsWithCart;

    function amount(): float
    {
        return $this->price;
    }
    
    function discount(): int
    {
        return $this->discount;
    }

}
```
Now you can manage model in cart, See example:
```php
use Masoudi\Laravel\Cart\Facades\Cart;

class ProductController {
    
    function addToCart(Product $product){
    
        Cart::withSession('unique-id-for-user')->add($product);
        
    }
    
}

```

Much better package documentation will be ready as soon!