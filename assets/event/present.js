import './present.scss'

const audioFiles = {
    aww: require('../audio/studio-audience-awwww-sound-fx.mp3'),
    clap: require('../audio/applause2.wav'),
    boo: require('../audio/boo2.wav'),
    laugh: require('../audio/laughter-2.mp3'),
}

import React, { useEffect, useState } from 'react'
import ReactDOM from 'react-dom'
import { useSSE, SSEProvider } from 'react-hooks-sse'

// https://stackoverflow.com/a/47686478
const useAudio = (url) => {
    const [audio] = useState(new Audio(url))
    const [playing, setPlaying] = useState(false)

    const toggle = () => setPlaying(!playing)

    useEffect(() => {
        playing ? audio.play() : audio.pause()
    }, [playing])

    useEffect(() => {
        audio.addEventListener('ended', () => setPlaying(false))
        return () => {
            audio.removeEventListener('ended', () => setPlaying(false))
        }
    }, [])

    return [playing, toggle]
}

const Component = ({ reactions }) => {
    const [stuff, setStuff] = useState(
        reactions.map((reaction) => ({ ...reaction, count: 0 }))
    )
    const message = useSSE('message', null)
    const sounds = {}
    Object.entries(audioFiles).forEach(([key, value]) => {
        sounds[key] = useAudio(value.default)
    })

    const [soundsReady, setSoundsReady] = useState(false)
    const playAllSounds = () => {
        Object.values(sounds).forEach((sound) => sound[1]())
        setSoundsReady(true)
    }

    useEffect(() => {
        if (message?.reaction) {
            const reaction = message?.reaction
            if (reaction) {
                const sound = sounds?.[reaction.id]
                // Play sound of not already playing.
                if (sound && !sound[0]) {
                    sound[1]()
                }
                setStuff(
                    stuff.map((item) => ({
                        ...item,
                        count: item.count + (reaction?.id === item.id ? 1 : 0),
                    }))
                )
            }
        }
    }, [message])

    return (
        <>
            {stuff.map((reaction) => (
                <div
                    key={reaction.id}
                    className="alert alert-primary"
                    role="alert"
                >
                    {reaction.id}: {reaction.count}
                </div>
            ))}

            {!soundsReady ? (
                <p>
                    Please click this button to allow playing sound when people
                    react:{' '}
                    <button
                        className="btn btn-primary"
                        onClick={() => playAllSounds()}
                    >
                        Play all sounds
                    </button>
                </p>
            ) : (
                <p>You're ready to get feedback!</p>
            )}
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
