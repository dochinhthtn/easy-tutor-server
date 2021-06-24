import React from 'react';
import { Link } from 'react-router-dom';

// let data = [
//     {name: 'Conversation 1', us}
// ];

export default function ConversationContainer(props) {

    let name = (props.name) ? props.name : props.users.map(user => user.name).join(", ");
    return (
        <div className={"border mb-2 rounded " + ((props.active) ? "bg-light" : "")}>
            <div className="p-2">
                <Link to={"/chat/" + props.id}>{name}</Link>
            </div>
        </div>
    );
}