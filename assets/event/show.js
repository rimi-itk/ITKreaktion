import './show.scss'

import React from 'react'
import ReactDOM from 'react-dom'

const http = require('http')

const App = ({ reactions, reactUrl }) => {
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
        <div class="reactions d-flex flex-column">
            {reactions.map((reaction) => (
                <div class="p-2 flex-fill">
                    <button
                        className="btn btn-primary btn-block btn-lg"
                        key={reaction.id}
                        type="button"
                        onClick={() => handleClick(reaction)}
                    >
                        {reaction.id}
                    </button>
                </div>
            ))}
        </div>
    )
}

const el = document.getElementById('app')
const options = JSON.parse(el.dataset.options || '{}')

ReactDOM.render(<App {...options} />, el)
