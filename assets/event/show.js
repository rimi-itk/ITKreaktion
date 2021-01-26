import React from 'react'
import ReactDOM from 'react-dom'

const http = require('http')

const App = ({ reactUrl }) => {
    // const eventSource = new EventSource(eventSourceUrl)
    // eventSource.onmessage = event => {
    //     console.log('event', event)
    // }
    //
    const handleClick = (stuff) => {
        const requestOptions = {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({ stuff }),
        }
        fetch(reactUrl, requestOptions)
            .then((response) => response.json())
            .then((data) => console.log(data))

        console.log('handleClick', stuff)
    }

    return (
        <pre>
            <button type="button" onClick={() => handleClick('boo')}>
                Click
            </button>{' '}
            {reactUrl}
        </pre>
    )
}

const el = document.getElementById('app')
const options = JSON.parse(el.dataset.options || '{}')

ReactDOM.render(<App {...options} />, el)
