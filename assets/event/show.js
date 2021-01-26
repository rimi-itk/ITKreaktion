import React from 'react'
import ReactDOM from 'react-dom'

const http = require('http')

const App = ({ reactions, reactUrl }) => {
    // const eventSource = new EventSource(eventSourceUrl)
    // eventSource.onmessage = event => {
    //     console.log('event', event)
    // }
    //
    const handleClick = (reaction) => {
        const requestOptions = {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({ reaction }),
        }
        fetch(reactUrl, requestOptions)
            .then((response) => response.json())
            .then((data) => console.log(data))

        console.log('handleClick', reaction)
    }

    return (
        <>
            {reactions.map((reaction) => (
                <button
                    key={reaction.id}
                    type="button"
                    onClick={() => handleClick(reaction)}
                >
                    {reaction.id}
                </button>
            ))}
        </>
    )
}

const el = document.getElementById('app')
const options = JSON.parse(el.dataset.options || '{}')

ReactDOM.render(<App {...options} />, el)
