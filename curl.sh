#!/usr/bin/env bash

 curl -s http://localhost:8765/
 echo
 curl -s http://localhost:8765/mock-server
 echo
 curl -s http://localhost:8765/hello
 echo
 curl -s http://localhost:8765/hello/something
 echo
 curl -s http://localhost:8765/mock-server/status
 echo
