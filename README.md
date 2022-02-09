# Professional PHP - Tutorial
The repo to follow the tutorial of the book: [Professional PHP](https://amzn.to/31rr8S1)

Run the app by executing the following command from the `public` folder: `php -S localhost:8000`

Reference: [Professional Php - sample code](https://github.com/PatrickLouys/professional-php-sample-code)

# Refactoring list
- Framework/Csrf/SymfonySessionTokenStorage.php -> string $key in methods store() and retrieve()
- src/Framework/Csrf/StoredTokenValidator.php -> string $key n methods validate() (NB! ci siamo accorti che la stringa $key ed il Token sembrano andare sempre insieme)
- Framework/Csrf/StoredTokenReader.php -> string $key n methods read() and generateToken() (NB! la stringa $key qui e da sola)