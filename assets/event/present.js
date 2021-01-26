import React from 'react'
import ReactDOM from 'react-dom'

const App = ({eventSourceUrl}) => {
    const eventSource = new EventSource(eventSourceUrl)
    eventSource.onmessage = event => {
        console.log('event', event)
    }

    return <pre>App {eventSourceUrl}</pre>
}

const el = document.getElementById('app')
const options = JSON.parse(el.dataset.options || '{}')

ReactDOM.render(
    <App {...options} />,
    el
)
