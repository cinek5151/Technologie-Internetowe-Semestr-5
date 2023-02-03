import React from 'react';
import deleteImage from './images/delete.svg';
import NewProductInput from "./NewProductInput";
import ProductItem from "./ProductItem";

class ShoppingList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            products: []
        };
        this.deleteList = this.deleteList.bind(this);
    }

    render() {

        this.state.products = [];

        for (let i = 0; i < this.props.selectedList?.products.length; i++) {
            this.state.products.push(
                <ProductItem productCompleted={this.productCompleted.bind(this)} ref={React.createRef()}
                             key={this.props.selectedList?.products[i].product_id}
                             productName={this.props.selectedList?.products[i].product_name}
                             productId={this.props.selectedList?.products[i].product_id}
                             completed={this.props.selectedList?.products[i].completed}
                             deleteProduct={this.deleteProduct.bind(this)}/>
            );
        }

        if (this.props.selectedList === null) {
            return <div className={'card list-items-container'}></div>;
        } else {
            return <div className={'card list-items-container'}>

                <div className={'card-header'}>
                    <div className={'header-with-button'}>
                        <span>{this.props.selectedList?.list_title}</span>
                        <img alt={'add new list'} src={deleteImage} onClick={this.deleteList}/>
                    </div>
                    <hr/>

                    <NewProductInput newProductAdded={this.addNewProduct.bind(this)}/>

                </div>

                <div className={'card-body'}>
                    <div className={'list-items'}>
                        {this.state.products}
                    </div>
                </div>

            </div>;
        }


    }

    addNewProduct(productName) {

        let newProductId = 1;

        if (this.state.products.length !== 0) {
            newProductId = this.state.products[this.state.products.length - 1].props.productId + 1;
        }

        this.state.products.push(
            <ProductItem productCompleted={this.productCompleted.bind(this)} ref={React.createRef()} key={newProductId}
                         productName={productName}
                         productId={newProductId}
                         completed={false}
                         deleteProduct={this.deleteProduct.bind(this)}/>
        );
        this.setState({
            products: this.state.products
        });

        this.props.addNewProduct(newProductId, productName);
    }

    productCompleted(productId, completed) {
        this.props.productCompleted(productId, completed);
    }

    deleteList() {
        this.props.removeList(this.props.id);
    }

    deleteProduct(productId) {
        this.props.deleteProduct(productId);
    }

}

export default ShoppingList;