import React from 'react';

class NewListInput extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            listName: ''
        };

        this._handleKeyDown = this._handleKeyDown.bind(this);

    }


    render() {
        return (
            <div className={'input-container'}>
                <input value={this.state.listName} type={'text'} placeholder={'Nowa lista'} onKeyDown={this._handleKeyDown.bind(this)} onInput={this.textInput.bind(this)}/>
                <button onClick={this.addNewList.bind(this)}>Dodaj</button>
            </div>
        );
    }

    _handleKeyDown = (e) => {
        if (e.key === 'Enter') {
            this.addNewList();
        }
    };

    addNewList(){
        this.props.newListAdded(this.state.listName);
        this.setState({
            listName: ''
        });
    }

    textInput(e){
        this.setState({
           listName: e.target.value
        });
    }

}

export default NewListInput;