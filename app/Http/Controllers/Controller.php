<?php

namespace App\Http\Controllers;

use App\Actions\InquiryChat;
use App\Actions\InquiryEmail;
use App\Actions\OrderCancelledNotification;
use App\Actions\OrderCompletedNotification;
use App\Actions\OrderCreatedNotification;
use App\Actions\OrderDeliveryNotification;
use App\Actions\OrderFailedNotification;
use App\Mail\SendInquiryEmail;

abstract class Controller
{
    protected InquiryChat $inquiryChat;
    protected InquiryEmail $inquiryEmail;
    protected OrderCancelledNotification $orderCancelledNotification;
    protected OrderCompletedNotification $orderCompletedNotification;
    protected OrderCreatedNotification $orderCreatedNotification;
    protected OrderDeliveryNotification $orderDeliveryNotification;
    protected OrderFailedNotification $orderFailedNotification;

    /**
     * @param InquiryChat $inquiryChat
     * @param InquiryEmail $inquiryEmail
     * @param OrderCancelledNotification $orderCancelledNotification
     * @param OrderCompletedNotification $orderCompletedNotification
     * @param OrderCreatedNotification $orderCreatedNotification
     * @param OrderDeliveryNotification $orderDeliveryNotification
     * @param OrderFailedNotification $orderFailedNotification
     */
    public function __construct(InquiryChat $inquiryChat, InquiryEmail $inquiryEmail, OrderCancelledNotification $orderCancelledNotification, OrderCompletedNotification $orderCompletedNotification, OrderCreatedNotification $orderCreatedNotification, OrderDeliveryNotification $orderDeliveryNotification, OrderFailedNotification $orderFailedNotification)
    {
        $this->inquiryChat = $inquiryChat;
        $this->inquiryEmail = $inquiryEmail;
        $this->orderCancelledNotification = $orderCancelledNotification;
        $this->orderCompletedNotification = $orderCompletedNotification;
        $this->orderCreatedNotification = $orderCreatedNotification;
        $this->orderDeliveryNotification = $orderDeliveryNotification;
        $this->orderFailedNotification = $orderFailedNotification;
    }


}
