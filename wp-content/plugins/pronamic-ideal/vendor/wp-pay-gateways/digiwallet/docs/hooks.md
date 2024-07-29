# Hooks

- [Actions](#actions)
- [Filters](#filters)

## Actions

### `pronamic_pay_webhook_log_payment`

*Webhook log payment.*

The `pronamic_pay_webhook_log_payment` action is triggered so the
`wp-pay/core` library can hook into this and register the webhook
call.

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$payment` | `\Pronamic\WordPress\Pay\Gateways\DigiWallet\Payment` | Payment to log.

Source: [src/ReportController.php](../src/ReportController.php), [line 119](../src/ReportController.php#L119-L128)

## Filters

### `pronamic_pay_digiwallet_report_url`

*Filters the DigiWallet report URL.*

If you want to debug the DigiWallet report URL you can use this filter
to override the report URL. You could for example use a service like
https://webhook.site/ to inspect the report requests from DigiWallet.

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$report_url` | `string` | DigiWallet report URL.

Source: [src/Gateway.php](../src/Gateway.php), [line 114](../src/Gateway.php#L114-L123)


<p align="center"><a href="https://github.com/pronamic/wp-documentor"><img src="https://cdn.jsdelivr.net/gh/pronamic/wp-documentor@main/logos/pronamic-wp-documentor.svgo-min.svg" alt="Pronamic WordPress Documentor" width="32" height="32"></a><br><em>Generated by <a href="https://github.com/pronamic/wp-documentor">Pronamic WordPress Documentor</a> <code>1.1.0</code></em><p>
