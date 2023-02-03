import React from 'react';

class List extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            active : false
        }
        this.unselectList = this.unselectList.bind(this);
    }

    render() {
        return (<span className={this.state.active ? 'list selected-list' : 'list'} onClick={this.selectList.bind(this)}>{this.props.listTitle}</span>);
    }

    unselectList() {
        this.setState({active: false});
    }

    selectList = () => {
        this.setState({active: true});
        this.props.click(this.props.listId);
    }

}

export default List;