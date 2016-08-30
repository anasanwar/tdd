<?php

class ShippingTest extends TestCase{

    /*
     * First Test case
     * User must be able to enter the shipping address
     * */
    public function testShipingTrackingDitales(){

        $details = array();
        $details['estimatedTime'] = '12:00pm';
        $details['currentLocation'] = 'Polanda';

        $shippingService = $this->createMock(ShippingService::class);
        $shippingService->method('getDetails')->
        willReturn(array('estimatedTime'=>'12:00pm', 'currentLocation'=>'Polanda'));
        $this->assertEquals($details, $shippingService->getDetails());


    }

    /*
     * Second Test case
     * Shipping service can provide tracking detailes like (estimated time, and current location)
     * */
    public function testUserToEnterShippingAddress(){


        $shippingService = $this->createMock(ShippingService::class);
        $shippingService->method('setAddress')->
        willReturn(true);
        $this->assertEquals(true,$shippingService->setAddress('Gaza, Palestine'));

    }

    /*
     * Third Test case
     * Successful shipping must change the Order status and send Email to the client
     * */
    public function testSuccessfulShippingChangeOrderStatusToShippedAndSendEmail()
    {
        // Create a stub for the SomeClass class.
        $ship = $this->createMock(Shipping::class);

        // Configure the stub.
        $ship->method('isOrderShipped')
            ->willReturn(true);

        $order = new Order("123456");
        $this->assertTrue($ship->isOrderShipped($order));
        $this->assertTrue($order->setOrderShipped());
        $this->assertTrue($order->getClient()->sendEmail());
        $this->assertEquals("Shipped",$order->getStatus());

    }

    public function testFailureShippingAndOrderStatusIsShipping()
    {
        // Create a stub for the SomeClass class.
        $ship = $this->createMock(Shipping::class);

        // Configure the stub.
        $ship->method('isOrderShipped')
            ->willReturn(false);

        $order = Order::find("123456");
        $this->assertFalse($ship->isOrderShipped($order));
        $this->assertEquals("Shipping",$order->getStatus());

    }

}
