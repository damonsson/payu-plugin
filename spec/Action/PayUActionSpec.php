<?php

namespace spec\BitBag\PayUPlugin\Action;

use BitBag\PayUPlugin\Action\PayUAction;
use BitBag\PayUPlugin\SetPayU;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayInterface;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Security\TokenInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\CustomerInterface;

final class PayUActionSpec extends ObjectBehavior
{
    function let()
    {
        $this->setApi(['environment' => 'secure', 'signature_key' => '123', 'pos_id' => '123']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PayUAction::class);
    }

    function it_executes(
        SetPayU $request,
        TokenInterface $token,
        CustomerInterface $customer,
        ArrayObject $model,
        SetPayU $setPayU,
        GetHumanStatus $status,
        GatewayInterface $gateway

    )
    {
        $request->getModel()->willReturn($model);
        $request->getToken()->willReturn($token);
        $request->getFirstModel()->willReturn($customer);


        $this->execute($request);
    }

    function it_throws_exception_when_model_is_not_array_object(SetPayU $request)
    {
        $request->getModel()->willReturn(null);

        $this
            ->shouldThrow(RequestNotSupportedException::class)
            ->during('execute', [$request]);
    }
}
