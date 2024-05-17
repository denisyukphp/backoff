init:
	docker build -t backoff:8.2 ./

exec:
	docker run --name backoff --rm --interactive --tty --volume ${PWD}:/usr/local/packages/backoff/ backoff:8.2 /bin/bash
