# PHP client for ProdWS SOAP Service
Deutsche Post provides a SOAP Service called "ProdWS", which is required to get product data to be able to automatically
create postage stamps via the "OneClickForApp" (1C4A) SOAP Service.

While there is a very good [PHP implementation](https://github.com/baltpeter/internetmarke-php) for this service by [baltpeter](https://github.com/baltpeter/), there was no PHP implementation for ProdWS.
So I did it, because I needed it, and I made it available for everyone to use because I wanted to save you the immense
pain of going through this.

While it is small, and not polished at all, I hope it is still useful to you!
I'd be very happy if you send me a message if it was useful - just so I know I made someone happy 😃

# Registering
Before you can use the ProdWS service, you need to register via a PDF form. Registration is only available in german language, as far as I know. But you're probably already registered if you found this repo 😉
The form and all official, really crappy documentation, can be found here: https://www.deutschepost.de/de/i/internetmarke-porto-drucken/downloads.html

# Thank you
A huge THANK you goes out to @baltpeter, because he saved me a ton of work with his [internetmarke-php](https://github.com/baltpeter/internetmarke-php) package!