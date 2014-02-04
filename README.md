# CoinPipe

CoinPipe is a small and lightweight cryptocurrency faucet script that's written in PHP and uses SQLite3. Yeah, you don't need to setup an entire MySQL server or whatever because that thing might be heavy, hell I don't know I'm not even a webdeveloper. Either way, at the moment this is almost a clear copy from the [GabenCoin SteamPipe](http://gbn.prospector.io), and because it's so small it should be easily modified to your needs. The entire code at the moment of writing is around 140 lines, so just dig into it and modify the script to your needs.

# Installation

1. Setup your favorite web server with PHP and SQLite3. I'm not holding your hand here, I expect you to know how to set it up.
2. Install `gcc`, `boost` and `boost-devel` from your lunix repositories. Just get the boost development libraries.
3. I assume you already have `git` because how else would you fetch this!?
4. Pull the latest version from the repository of your `cryptocoin`, where cryptocoin can be anything, gabencoin, litecoin, peercoin, bitcoin whatever.
5. Go to the `src/` directory of your `cryptocoin`.
6. `make -f makefile.unix clean`.
7. `make -f makefile.unix USE_UPNP=cryptocoind`. Notice the `d` at the end.
8. Run that motherfucker `./cryptocoind`. Make sure it works by checking the `debug.log` somewhere in the folders. If it isn't, well, fix it somehow!
9. Make sure it runs 24/7.
10. Put this project somewhere on your webserver and edit `config.php`. Feel free to edit the source in `index.php` and `pipe.php` to edit the entire faucet to your preferences.
11. Pray to almighty GabeN your shit works. If it doesn't, well, tough luck!

# License
That one MIT license that tells you you can do whatever the fuck you want with this. But also that Creative Commons 3.0 thingy that tells you to credit me!