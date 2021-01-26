import React, { useEffect, useState } from 'react'
import ReactDOM from 'react-dom'
import { useSSE, SSEProvider } from 'react-hooks-sse'

const Component = ({ reactions }) => {
    const [stuff, setStuff] = useState(
        reactions.map((reaction) => ({ ...reaction, count: 0 }))
    )
    const message = useSSE('message', null)

    useEffect(() => {
        if (message?.reaction) {
            const reaction = message?.reaction
            setStuff(
                stuff.map((item) => ({
                    ...item,
                    count: item.count + (reaction?.id === item.id ? 1 : 0),
                }))
            )
        }
    }, [message])

    return (
        <>
            {stuff.map((reaction) => (
                <div key={reaction.id}>
                    {reaction.id}: {reaction.count}
                </div>
            ))}
        </>
    )
}

const App = ({ eventSourceUrl, reactions }) => {
    return (
        <SSEProvider endpoint={eventSourceUrl}>
            <Component reactions={reactions} />
        </SSEProvider>
    )
}

const el = document.getElementById('app')
const options = JSON.parse(el.dataset.options || '{}')

ReactDOM.render(<App {...options} />, el)
