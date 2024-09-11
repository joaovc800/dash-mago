export const api = {
    base: (endpoint) => `${window.origin}/freelancer/dashboard-mago/app/controllers/${endpoint}.php`
}

export const requests = {

    get: async function (url, params = {}, config) {

        if (config && config.isLoadingInput.length > 0) {
            isLoadingInput({
                inputs: config.isLoadingInput,
                type: 'start'
            })
        }

        const queryParams = new URLSearchParams(params).toString();
        const fullUrl = `${url}?${queryParams}`;

        try {
            const response = await fetch(fullUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error(`Erro ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro na requisição GET:', error);
            throw error;
        } finally {
            if (config && config.isLoadingInput.length > 0) {
                isLoadingInput({
                    inputs: config.isLoadingInput,
                    type: 'finish'
                })
            }
        }
    },

    post: async function (url, body = {}, config) {

        if (config && config.isLoadingInput.length > 0) {
            isLoadingInput({
                inputs: config.isLoadingInput,
                type: 'start'
            })
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body),
            });

            if (!response.ok) {
                throw new Error(`Erro ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro na requisição POST:', error);
            throw error;
        } finally {
            if (config && config.isLoadingInput.length > 0) {
                isLoadingInput({
                    inputs: config.isLoadingInput,
                    type: 'finish'
                })
            }
        }
    }
}

export function isLoadingInput({ inputs, type }) {
    const config = {
        start: {
            classListFunc: 'add',
            attributeFunc: {
                fn: 'setAttribute',
                args: ['disabled', 'disabled']
            }
        },
        finish: {
            classListFunc: 'remove',
            attributeFunc: {
                fn: 'removeAttribute',
                args: ['disabled']
            }
        }
    }

    const { classListFunc, attributeFunc } = config[type]

    inputs.forEach(({ input }) => {
        const controlIsLoadding = input.nodeName === 'BUTTON' ? input : input.closest('.control')
        controlIsLoadding.classList[classListFunc]('is-loading')
        input[attributeFunc.fn](...attributeFunc.args)
    })
}