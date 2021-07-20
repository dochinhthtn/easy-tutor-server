import React from 'react';

export default function MessageContainer(props) {
    return (
        <div className={"mb-1 " + (props.owned ? "text-right" : "text-left")}>
            <span className={"d-inline-block p-2 rounded " + (props.owned ? "bg-primary text-white" : "bg-light")}>{props.content}</span>
        </div>
    );
}