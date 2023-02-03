import React from 'react';

import List from "./List";
import NewListInput from "./NewListInput";

class ListsContainer extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            selectedListId: -1,
            lists: []
        }
        this.selectList = this.selectList.bind(this);
        this.removeList = this.removeList.bind(this);
        this.newListAdded = this.newListAdded.bind(this);
    }


    render() {

        if (this.state.lists.length === 0) {
            for (let i = 0; i < this.props.shoppingLists.lists.length; i++) {
                this.state.lists.push(
                    <List key={this.props.shoppingLists?.lists[i]?.list_id} ref={React.createRef()}
                          listId={this.props.shoppingLists?.lists[i]?.list_id}
                          listTitle={this.props.shoppingLists?.lists[i]?.list_title}
                          click={this.selectList}/>
                );
            }
        }

        return <div className={'card shopping-lists-container'}>
            <div className={'card-header'}>
                <div className={'header-with-button'}>
                    <span>Listy zakupów</span>
                </div>
                <hr/>
                <NewListInput newListAdded={this.newListAdded}/>
            </div>

            <div className={'card-body'}>
                {this.state.lists}
            </div>

        </div>;
    }

    selectList(listId) {
        if (this.state.selectedListId !== -1 && this.state.selectedListId !== listId) {
            this.state.lists[this.state.lists.findIndex(l => l.props.listId === this.state.selectedListId)].ref.current.unselectList();
        }
        this.setState({selectedListId: listId});
        this.props.selectList(listId);
    }

    removeList(listId) {
        this.state.lists[this.state.lists.findIndex(l => l.props.listId === listId)].ref.current.unselectList();
        this.state.lists.splice(this.state.lists.findIndex(l => l.props.listId === listId), 1)
        this.setState({
            selectedListId: -1,
            lists: this.state.lists
        });
    }

    newListAdded(listName) {

        let newListId = 1;


        if (this.state.lists.length !== 0) {
            newListId = this.state.lists[this.state.lists.length - 1].props.listId + 1;
        }

        this.state.lists.push(
            <List key={newListId} ref={React.createRef()} listId={newListId}
                  listTitle={listName}
                  click={this.selectList}/>
        );

        this.setState({
            lists: this.state.lists
        });

        this.props.addNewList(listName, newListId);
    }

}

export default ListsContainer;