<?php
   /*
   Plugin Name: Event Tickets Email Notification
   Plugin URI:  http://
   Description: Enable event tickets/rsvp to send an email notification to the recipient after checkout on woocommerce.
   Version: 1.0
   Author: Liveby6
   Author URI: https://liveby5.com/
   License: GPLv2 or later
   License URI: https://www.gnu.org/licenses/gpl-2.0.html
   Text Domain: event-tickets-email-notification
   Domain Path: /lang/
    */

   /*
    Copyright 2019 by Liveby5

    This program is owned and developed under Liveby5 and will be used
    by the Company alone and limit to use on it's personal projects only.

    */

   if ( ! defined( 'ABSPATH' ) ) {
      die( '-1' );
   }


   /*** BCC event organizers email on all Event Tickets' RSVP and commerce ticket emails notification for recipient ***/
   function wc_change_admin_new_order_email_recipient($recipient, $order) { 
      if ($order) {
      global $woocommerce;
      
      // Iterating through each WC_Order_Item_Product objects 
      foreach ($order->get_items() as $item_key => $item_values): 
         $product_id = $item_values->get_product_id(); // the Product id 
         $item_data = $item_values->get_data(); // if item data is needed 
      endforeach; 
      
      $event_id = tribe_events_get_ticket_event($product_id); 
      $org_email = tribe_get_organizer_email($event_id, false); 
      if($org_email !='') { 
         $recipient .= ', '.$org_email; // apend new email from event oraniser 
         return $recipient; 
      } else {
         return $recipient; 
      } 
      }

   } 
   add_filter('woocommerce_email_recipient_new_order', 'wc_change_admin_new_order_email_recipient', 1, 2);

