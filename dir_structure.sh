#!/bin/bash

# Function to print directory structure with max depth
print_structure() {
    local dir_path=$1
    local prefix=$2
    local depth=$3

    # Print the directory name
    echo "${prefix}${dir_path##*/}/"

    # Check if the current depth is less than the maximum depth
    if [ $depth -lt 2 ]; then
        # Find all directories in the current directory
        local directories=$(find "$dir_path" -maxdepth 1 -mindepth 1 -type d | sort)

        # Iterate over each directory
        for directory in $directories; do
            # Recursively call the function with an updated prefix and depth
            print_structure "$directory" "$prefix    " $((depth + 1))
        done
    fi
}

# Get the target directory from the first argument, default to the current directory
target_dir=${1:-.}

# Print the structure of the target directory with initial depth of 0
print_structure "$target_dir" "" 0
