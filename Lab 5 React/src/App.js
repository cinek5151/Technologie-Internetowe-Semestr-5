import React, {useRef} from 'react';
import ListsContainer from "./ListsContainer";
import ShoppingList from "./ShoppingList";

import shoppingLists from './shopping_list.json';
import list from "./List";

class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            selectedList: null,
            selectedId: -1,
            shoppingLists: null,
            listsContainerRef: React.createRef()
        };
        this.isDataExistsInStorage = this.isDataExistsInStorage.bind(this);
        this.getDataFromStorage = this.getDataFromStorage.bind(this);
        this.saveDataToStorage = this.saveDataToStorage.bind(this);
        this.selectList = this.selectList.bind(this);
        this.addNewList = this.addNewList.bind(this);
        this.removeList = this.removeList.bind(this);
    }


    render() {

        if (this.state.shoppingLists === null) {
            if (this.isDataExistsInStorage()) {
                this.state.shoppingLists = this.getDataFromStorage();
            } else {
                this.state.shoppingLists = shoppingLists;
            }
        }

        return (<div className={'main-container'}>
                <ListsContainer ref={this.state.listsContainerRef} shoppingLists={this.state.shoppingLists}
                                selectList={this.selectList} removeList={this.removeList} addNewList={this.addNewList}/>
                <ShoppingList addNewProduct={this.addNewProduct.bind(this)}
                              productCompleted={this.productCompleted.bind(this)}
                              selectedList={this.state.selectedList}
                              id={this.state.selectedId}
                              removeList={this.removeList}
                              deleteProduct={this.deleteProduct.bind(this)}/>
            </div>
        );
    }

    selectList = (listId) => {
        this.setState({
            selectedList: this.state.shoppingLists.lists[this.state.shoppingLists.lists.findIndex(l => l.list_id === listId)],
            selectedId: listId
        });
    }

    addNewList(listTitle, listId) {
        this.state.shoppingLists.lists.push({
            list_id: listId,
            list_title: listTitle,
            products: []
        });
        this.saveDataToStorage();
        this.setState({
            shoppingLists: this.state.shoppingLists
        });
    }

    removeList(listId) {
        this.state.shoppingLists.lists.splice(this.state.shoppingLists.lists.findIndex(l => l.list_id === listId), 1);
        this.setState({
            selectedList: null,
            selectedId: -1,
            shoppingLists: null
        });

        this.state.listsContainerRef.current.removeList(listId);
        this.saveDataToStorage();
    }

    addNewProduct(productId, productName) {
        this.state.shoppingLists.lists[this.state.shoppingLists.lists.findIndex(l => l.list_id === this.state.selectedId)].products.push({
            product_id: productId,
            product_name: productName,
            completed: false
        });
        this.setState({
            shoppingLists: this.state.shoppingLists
        });
        this.saveDataToStorage();
    }

    productCompleted(productId, completed) {
        let lists = this.state.shoppingLists.lists;
        let list = lists[this.state.shoppingLists.lists.findIndex(l => l.list_id === this.state.selectedId)];
        list.products[list.products.findIndex(p => p.product_id === productId)].completed = completed;
        lists[this.state.shoppingLists.lists.findIndex(l => l.list_id === this.state.selectedId)] = list;
        this.state.shoppingLists.lists = lists;
        this.setState({
            shoppingLists: this.state.shoppingLists
        });
        this.saveDataToStorage();
    }

    deleteProduct(productId) {
        this.state.shoppingLists.lists[this.state.shoppingLists.lists.findIndex(l => l.list_id === this.state.selectedId)].products.splice(
            this.state.shoppingLists.lists[this.state.shoppingLists.lists.findIndex(l => l.list_id === this.state.selectedId)].products.findIndex(p => p.product_id === productId)
            , 1);
        this.setState({
            shoppingLists: this.state.shoppingLists
        });
        this.saveDataToStorage();

    }

    saveDataToStorage() {
        localStorage.setItem('shopping_lists', JSON.stringify(this.state.shoppingLists));
    }

    isDataExistsInStorage() {
        return localStorage.getItem('shopping_lists') !== null;
    }

    getDataFromStorage() {
        return JSON.parse(localStorage.getItem('shopping_lists'));
    }

}

export default App;