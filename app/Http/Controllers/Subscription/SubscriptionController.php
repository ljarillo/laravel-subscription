<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function checkout()
    {
        if(auth()->user()->subscribed('default'))
            return redirect()->route('subscriptions.premium');

        return view('subscriptions.checkout',[
            'intent' => auth()->user()->createSetupIntent(),
            'plan' => session('plan')
         ]);
    }

    public function store(Request $request)
    {
        $plan = session('plan');

        $request->user()
            ->newSubscription('default', $plan->stripe_id)
            ->create($request->token);

        return redirect()->route('subscriptions.premium');
    }

    public function premium()
    {
        return view('subscriptions.premium');
    }

    public function account()
    {
        $user = auth()->user();
        $invoices = $user->invoices();
        $subscription = $user->subscription('default');
        return view('subscriptions.account', compact('invoices', 'subscription', 'user'));
    }

    public function downloadInvoice($invoiceId)
    {
        return auth()->user()
            ->downloadInvoice($invoiceId,[
                'vendor' => config('app.name'),
                'product' => 'Assinatura VIP Mensal'
            ]);
    }

    public function cancel()
    {
        auth()->user()->subscription('default')->cancel();

        return redirect()->route('subscriptions.account');
    }

    public function resume()
    {
        auth()->user()->subscription('default')->resume();

        return redirect()->route('subscriptions.account');
    }
}
