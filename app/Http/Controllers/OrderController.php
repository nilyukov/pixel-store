<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use Domain\Order\Actions\NewOrderAction;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Domain\Order\Processes\AssignCustomer;
use Domain\Order\Processes\AssignProducts;
use Domain\Order\Processes\ChangeStateToPending;
use Domain\Order\Processes\CheckProductQuantities;
use Domain\Order\Processes\ClearCart;
use Domain\Order\Processes\DecreaseProductsQuantities;
use Domain\Order\Processes\OrderProcess;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class OrderController extends Controller
{

    #[Get('/order', name: 'order')]
    /**
     * @throws Exception
     */
    public function index(): \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            flash()->alert('Корзина пуста');

            return session()->previousUrl()
                ? back()
                : redirect()->route('home');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }

    #[Post('/order', name: 'order.handle')]
    public function handle(OrderFormRequest $request, NewOrderAction $action): RedirectResponse
    {
        $dto = NewOrderDTO::fromRequest($request);
        $order = $action($dto);

        (new OrderProcess($order))->processes([
            new CheckProductQuantities(),
            new AssignCustomer($dto),
            new AssignProducts(),
            new DecreaseProductsQuantities(),
            new ChangeStateToPending(),
            new ClearCart()
        ])->run();

        return redirect()->route('home');
    }
}
