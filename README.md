# bitmarket
An experimental Bitcoin Escrow plugin for WordPress. By experimental I mean you need to do several other things beyond installing this plugin in order to be able to use it.

You need your own [Bitcoin node](https://en.bitcoin.it/wiki/Bitcoind) preferably on the same server as the WordPress running this plugin. 

Your Bitcoin node should have a [wallet notify script](https://en.bitcoin.it/wiki/Running_Bitcoin) which notifies WordPress when there is a new incoming transaction. This is not included in the plugin.

And finally this plugin is only for handling the Bitcoin wallet system. The actual services and products sold by the vendors are in a different plugin. Originally this was created for [3d printing escrow website](https://tulostinkartta.fi). It was better to split the Bitcoin and 3d printing parts into separate plugins.   
