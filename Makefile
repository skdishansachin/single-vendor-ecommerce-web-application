pint:
	composer run pint

pint-dirty:
	composer run pint-dirty

stripe-listen:
	stripe listen --forward-to http://localhost:8000/stripe/webhook

queue:
	php artisan queue:work