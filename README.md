# NTIAutoDeleteBundle


### Installation

1. Install the bundle using composer:

    ```
    $ composer require ntidev/auto-delete-bundle "dev-master"
    ```

2. Add the bundle configuration to the AppKernel

    ```
    public function registerBundles()
    {
        $bundles = array(
            ...
            new NTI\AutoDeleteBundle\NTIAutoDeleteBundle(),
            ...
        );
    }
    ```

3. Update the database schema
    
    ```
    $ php app/console doctrine:schema:update
    ```

## Usage

1. Schedule a cronjob to execute the following commnad:
    
    ```
    $ php app/console nti:auto-delete:run   
    ```

2. Register paths to be auto deleted using the following generator:

    ```
    $ php app/console nti:auto-delete:new-entry

    ```
    
    Help Information:
    
    ```
        
    Usage:
      nti:auto-delete:new-entry [options] [--] <path> <seconds>
    
    Arguments:
      path                                   The path to be deleted
      seconds                                The amount of seconds until the path is deleted.
    
    Options:
          --disabled[=DISABLED]              If the entry should be disabled when created. [default: false]
          --no-recursive[=NO-RECURSIVE]      If set and the path is a directory the process won't proceed recursively through subdirectories. [default: false]
          --keep-empty-dir[=KEEP-EMPTY-DIR]  If set, empty directories won't be removed. [default: false]
      -h, --help                             Display this help message
      -q, --quiet                            Do not output any message
      -V, --version                          Display this application version
          --ansi                             Force ANSI output
          --no-ansi                          Disable ANSI output
      -n, --no-interaction                   Do not ask any interactive question
      -s, --shell                            Launch the shell.
          --process-isolation                Launch commands from shell as a separate process.
      -e, --env=ENV                          The Environment name. [default: "dev"]
          --no-debug                         Switches off debug mode.
      -v|vv|vvv, --verbose                   Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
    
    Help:
      This command will create a new AutoDeleteEntry.

    ```
