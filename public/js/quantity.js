function updateInputValue(selector,increment = true){

    const input = document.querySelector(selector);

    let newValue =  parseInt(input.value);
    const maxValue = parseInt(input.max);
    const minValue = parseInt(input.min);

    if(increment){
        newValue += 1;
    }else{
        newValue -= 1;
    }

    if(newValue > maxValue || newValue < minValue){
        return;
    }

    input.value = newValue;
}
