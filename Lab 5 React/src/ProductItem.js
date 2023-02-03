import React from 'react';
import deleteImage from './images/delete-button.svg';

class ProductItem extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            completed: this.props.completed
        }

    }

    render() {
        return (
            <div className={ this.state.completed ? 'list-item completed' : 'list-item'}>
                <span onClick={this.completeProduct.bind(this)}>{this.props.productName}</span>
                <img alt={'remove'} src={deleteImage} onClick={this.deleteProduct.bind(this)}/>
            </div>
        );
    }

    completeProduct(){

        this.props.productCompleted(this.props.productId, !this.state.completed);

        this.setState({
            completed: !this.state.completed
        })
    }

    deleteProduct(){
        this.props.deleteProduct(this.props.productId);
    }

}

export default ProductItem;