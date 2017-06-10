# backup

Backup script for demos.

A simple script that incrementally backs up every demo file to a local directory.

## Usage

The following environment variables are required for the script
 
 - `SOURCE`: The url of the api to backup the demos from (`https://api.demos.tf`)
 - `STORAGE_ROOT`: The directory to store the demos in
 - `STATE_FILE`: The textfile to store the backup progress in between runs
 
The script will look in a `.env` file if the variables aren't set in the environment
