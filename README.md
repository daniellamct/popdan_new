# POPDAN
A POPCAT clone, but the cat is me!

## Deployment
### via Anaconda

Create Python3.8 environment
> (base) \$ conda create -n "popdan" python=3.8

Activate environment
> (base) \$ conda activate popdan

Install requirements
> (popdan) \$ pip install -r requirements.txt

Start the server
> (popdan) \$ python app.py

### Reverse Proxy
A Caddyfile like this should work
```
https://popdan.example.com {
    reverse_proxy https://localhost:<port_to_conf_in_app.py>
}
```

## License
GPL-3.0
