((Snowboard, gtag) => {
    class Measurement extends Snowboard.Singleton {
        construct() {
            this.enabled = false;
            this.alias = null;
            this.measurementId = null;
            this.clientId = null;
            this.events = [];
        }

        listens() {
            return {
                ready: 'ready',
            }
        }

        ready() {
            this.alias = WINTER_GA_ALIAS;
            this.measurementId = WINTER_GA_MEASUREMENT_ID;
            this.clientId = WINTER_GA_CLIENT_ID;

            if (!this.alias) {
                console.info('Missing Google Analytics measurement component alias. Measurement cannot be enabled.');
                return;
            }

            if (!this.measurementId) {
                console.info('Missing Google Analytics measurement ID. Measurement cannot be enabled.');
                return;
            }

            if (!gtag) {
                console.info('Google Tag Manager is not available on this page. Measurement cannot be enabled.');
                return;
            }

            gtag('get', this.measurementId, 'client_id', (clientId) => {
                if (this.clientId !== clientId) {
                    Snowboard.request(`${this.alias}::onStoreClientId`, {
                        data: {
                            clientId
                        }
                    });
                    this.clientId = clientId;
                }

                this.enabled = true;
                this.runEvents();
            });
        }

        event(name, data) {
            this.events.push({
                name,
                data,
            });

            if (this.enabled) {
                this.runEvents();
            }
        }

        runEvents() {
            this.events.forEach((event) => {
                gtag('event', event.name, event.data);
                console.log('logged event', event);
            });
            this.events = [];
        }
    }

    Snowboard.addPlugin('winter.googleanalytics.measurement', Measurement);
})(window.Snowboard, window.gtag);
