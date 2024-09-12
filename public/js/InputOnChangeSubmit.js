function handleInputsChange(formSelector, eventType, ...inputs) {

    const form = document.querySelector(formSelector);

    if (!form) {
        console.error('Form is null');
        return;
    }

    inputs.forEach(inputSelector => {

        const input = document.querySelector(inputSelector);

        if (!inputSelector) {
            console.warn(`cant find ${inputSelector}`);
            return;
        }

        input.addEventListener(eventType, () => form.submit());
    })

}

function handleInputChange(formSelector, eventType, inputSelector, callback = (value) => true) {

    const form = document.querySelector(formSelector);
    const input = document.querySelector(inputSelector);

    if (!form) {
        console.error('Form is null');
        return;
    }

    if (!inputSelector) {
        console.warn(`cant find ${inputSelector}`);
        return;
    }

    input.addEventListener(eventType, () => {
        if (callback(input.value)) {
            form.submit();
        }
    });

}

