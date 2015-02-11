rem This script builds from the HEAD not from the local machine
del /f build.zip
git archive --format=zip HEAD > build.zip