=== Kronos Express Shipping for WooCommerce ===
Contributors: azasisgod,tsakis,bseltd,
Tags: courier, shipping, shipping woocommerce, cyprus, eshop, greece
Requires at least: 4.0
Tested up to: 5.9.3
Stable tag: 1.0.16
License: LGPLv3

Kronos Express Shipping for WooCommerce

== Description ==

Kronos Express Shipping for WooCommerce plugin integrates your e-shop with the Kronos Express courier services. The integration takes less than 5 minutes. 
The plugin allows to manage (Issue, Print, Cancel) your shipping labels from WooCommerce Orders bulk actions and from a specific order's page. 
Kronos Express Shipping for WooCommerce plugin currently allows shipments  
* Within the Cypriot territory
* From Greece to Cyprus.

The plugin allows you to:

= Sandbox Account = 

Create Sandbox account through the Administrator's panel. Credentials will be sent via email.

= Live Account =

Able to request for a Live account through the Administrator panel.
Upon approval, the credentials will be provided by Kronos Express.

= Shipping Methods =

Currently two shipping methods available to choose from, 
1. For Cyprus shipping.
a. KRONOSEXPRESS DOOR EXPRESS - This informs the courier to deliver the parcel directly to customer's address.
b. KRONOSEXPRESS POINT EXPRESS - This allows the customer to select a Kronos Express pickup point and informs the courier to deliver the parcel to the selected point.

2. For Greece to Cyprus shipping.
a. KRONOSEXPRESS DOOR EXPRESS - This informs the courier to deliver the parcel directly to customer's address faciliating air freight service.
b. KRONOSEXPRESS POINT EXPRESS - This allows the customer to select a Kronos Express pickup point and informs the courier to deliver the parcel to the selected point faciliating air freight service.
c. KRONOSEXPRESS DOOR ECONOMY - This informs the courier to deliver the parcel directly to customer's address faciliating sea freight service.
d. KRONOSEXPRESS POINT ECONOMY - This allows the customer to select a Kronos Express pickup point and informs the courier to deliver the parcel to the selected point faciliating sea freight service.
	
Each method has their own settings, which allows the Administrator to set the following options: 
1. Flat Rate cost (The shipping cost that will appear on cart and checkout pages)
2. Get Realtime Prices (The plugin will get prices in realtime on checkout/cart pages and disable flat rate option.)
2a. Handling Fees (Fee to charge ontop of realtime price)
3. Free Shipping (Enter the total cart value, excluding shipping and taxes, where this shipping option will offer free shipping)
4. Maximum Weight Allowed (It will not show on checkout if total weight of all items is more than the specified value)
5. Tax Status (Specify if the cost is taxable or not)

Customers will see on the checkout and cart pages, the configured shipping methods. For Cyprus, only EXPRESS options are available.

= Tracking =

The plugin provides a shortcode to embed the tracking system into any page of your choice.

= Customer Notification =

Upon issuing or cancelling a Kronos Express shipping label, a noted is created on customer's order.
The plugin provides the option to automatically notify the customer via the built-in WooCommerce emailing system, when a Kronos Express shipping label is issued, cancelled or when an order is marked as completed.
The issued notification includes tracking number and tracking link.



= More Information =

For customized plugin or general inquiries, you may [contact us](https://bse.com.cy/contact-us).

== Installation ==

Upload the plugin and activate it. 
Follow the screenshots for step-by-step guide.

== Screenshots ==

1. Find the Administrator's panel under WooCommerce -> Shipping -> Kronos Express Shipping WooCommerce. 
2. Step 1: Create Sandbox account by clicking the "Create Sandbox Account" button. Fill in the required fields and credentials will be emailed to you via email (be sure to check your spam folder).
3. Step 2: Request for a Live account by clicking the "Get Account" button. Fill in the required fields and a Kronos Express representative to will get back to you as soon as possible.
1. Step 3: Fill in the credentials (API Username, API Password, API Unique Key) of Live/Sandbox on the Administrator's panel. If it's a sandbox account, check the "Enable Sandbox" checkbox.
4. Step 4: Configure the available shipping methods under WooCommerce -> Shipping zones -> Add shipping method.  
5. Step 5: Configure the shipping method's options such as Flat Rate or Get RealTime Prices.
1. Notifications: check the "Tracking Customer Notification" in order to email customer automatically upon issuing or cancelling a Kronos Express shipping label.
6. Embedded Tracking System: To embed the tracking system use the shortcode, which is displayed on Administrator's panel, on any of your pages. 
7. Screenshot demonstrates how the shipping methods are displayed on Cart page.
8. Screenshot demonstrates how the shipping methods are displayed on Checkout page.
9. Screenshot demonstrates how to issue a shipping label from within an order.
10. Screenshot demonstrates how to reprint or cancel the shipping label from within an order.
11. Screenshot demonstrates how to issue shipping labels from bulk actions on order's page.
12. Screenshot demonstrates how to reprint or cancel shipping labels from bulk actions on order's page.
13. Functionality to print delivery notes, regardless of user's selection of shipping method.
15. Set shipping prices by Cart Amount with multiple ranges

== Changelog ==

= 1.0.16 =
*Release Date - 23 May, 2022*
* Bug Fixes:
* Fixed an issue where points didn't display on checkout. This was caused by plugin that were adding adding url parameter on wc-ajax=update_order_review such as elementor

= 1.0.15 =
*Release Date - 12 April, 2022*
* General Notes:
* Added compatibility for PHP >= 8.0
* Added compatibility for WordPress 5.9.3
* Added compatibility for WooCommerce 6.3.1
*
* Features:
* Set shipping prices by Cart Amount with multiple ranges
*
* Bug Fixes:
* Fixed an issue with parent class on PHP >= 8.0

= 1.0.14 =
*Release Date - 06 May, 2021*
* General Notes:
* Added compatibility with WooCommerce 5.2.2
* Added compatibility with WordPress 5.7.1
*
* Bug Fixes:
* Printing from Bulk options in WooCommece -> Orders sometimes resulted in an incorrect shipping method

= 1.0.13 =
*Release Date - 07 October, 2020*
* General Notes:
* Added compatibility with WooCommerce 4.5.2 
* Added compatibility with WordPress 5.5.1
*
* Optimizations:
* Implemented functionality to use curl when available to communicate with the API service.

= 1.0.12 =
*Release Date - 21 July, 2020*
* General Notes:
* Tested compatibility with WooCommerce 4.3
*
* Bug Fixes:
* Fixed a bug where admin ajax url was adding an empty space

= 1.0.11 =
*Release Date - 11 June, 2020*

* General Notes:
* Successfully tested for WooCommerce 4.2 
* Added language support for Greek and English WordPress websites
* Able to create Aller-Retour vouchers
* Various optimizations
* Bug Fixes:
* Fixed a bug where the admin couldn't create voucher if the phone number contained special characters (such as +).
* Fixed a bug where pickup locations wouldn't show if a single shipping method was defined and was a kronosexpress point service.


= 1.0.10 = 
*Release Date - 10 May, 2020*

* General Notes:
* Added WooCommerce 4.1 compatibility
*
* Bug Fixes:
* Fixed a bug where the client side's JS files wouldn't load if there were no available shipping methods during the pageload of checkout page
*
* New Features:
* Ability to provide traking link to customers when an order is marked as completed
*
* For Developers:
* Added two filters to amend Pickups Locations. e.g translate, add/remove locations, etc
* translate_optgroups_kronosexpress
* translate_warehouses_kronosexpress


= 1.0.9 =
*Release Date - 30 April, 2020*

* Sanitizing shipping fields for better compatibility
* Able to set user friendly shipping name
* Points have been sorted and grouped based on districts

= 1.0.8 =
*Release Date - 21 April, 2020*

* Handling special character on clients' addresses

= 1.0.7 =
*Release Date - 14 April, 2020*

* Bug fix to accept weights and cod amounts as integers

= 1.0.6 =
*Release Date - 13 April, 2020*

* Shop Manager can now issue/cancel delivery notes.

= 1.0.5 =
*Release Date - 11 April, 2020*

* Functionality to print delivery notes, regardless of user's selection of shipping method.
* Added compatibility for Woocommerce 4.01
* Added compatibility for Wordpress 5.4

= 1.0.4 =
*Release Date - 22 January, 2020*

* Fixed an issue on checkout not fetching Locations due to recent WooCommerce 3.9 tweak. "Eliminate extra update order AJAX request on checkout page load. #24271"

= 1.0.3 =
*Release Date - 22 January, 2020*

* Added compatibility for WordPress 5.3.2
* Added compatibility for WooCommerce 3.9

= 1.0.2 =
*Release Date - 16th December, 2019*

* Implemented Greece to Cyprus services, via air and sea freight 

= 1.0.1 =
*Release Date - 3rd December, 2019*

* Added the option to select a Tax status (Taxable, None)
* Added the option to get prices in realtime from KronosExpress Web Services
* Added the option to charge an amount ontop of realtime price (Handling Fees)
* Added the option to provide Free Shipping to customers if a certain amount of total cart is surpassed.
* Added two new shipping methods (DOOR ECONOMY and POINT ECONOMY) for an upcoming release.

= 1.0.0 =
*Release Date - 13th November, 2019*

* Initial Release
