import React from 'react';

class NewProductInput extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
          productName: ''
        };

        this._handleKeyDown = this._handleKeyDown.bind(this);
    }


    render() {
        return (
            <div className={'input-container'}>
                <input value={this.state.productName} type={'text'} placeholder={'Nowy produkt'} onKeyDown={this._handleKeyDown} onInput={this.textInput.bind(this)}/>
                <button onClick={this.addNewProduct.bind(this)}>Dodaj</button>
            </div>
        );
    }

    _handleKeyDown = (e) => {
        if (e.key === 'Enter') {
            this.addNewProduct();
        }
    };

    addNewProduct(){
        this.props.newProductAdded(this.state.productName);
        this.setState({
            productName: ''
        });
    }

    textInput(e){
        this.setState({
            productName: e.target.value
        });
    }

}

export default NewProductInput;