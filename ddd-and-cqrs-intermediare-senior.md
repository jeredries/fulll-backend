## [back/ddd/cqrs] Vehicle fleet parking management

### Instructions

I have a vehicle fleet and I want to manage where every vehicle is parked.

### Step 1

register_vehicle.feature

```feature
Feature: Register a vehicle

    In order to follow many vehicles with my application
    As an application user
    I should be able to register my vehicle

    @critical
    Scenario: I can register a vehicle
        Given my fleet
        And a vehicle
        When I register this vehicle into my fleet
        Then this vehicle should be part of my vehicle fleet

    Scenario: I can't register same vehicle twice
        Given my fleet
        And a vehicle
        And I have registered this vehicle into my fleet
        When I try to register this vehicle into my fleet
        Then I should be informed this this vehicle has already been registered into my fleet

    Scenario: Same vehicle can belong to more than one fleet
        Given my fleet
        And the fleet of another user
        And a vehicle
        And this vehicle has been registered into the other user's fleet
        When I register this vehicle into my fleet
        Then this vehicle should be part of my vehicle fleet
```

park_vehicle.feature

```feature
Feature: Park a vehicle

    In order to not forget where I've parked my vehicle
    As an application user
    I should be able to indicate my vehicle location

    Background:
        Given my fleet
        And a vehicle
        And I have registered this vehicle into my fleet

    @critical
    Scenario: Successfully park a vehicle
        And a location
        When I park my vehicle at this location
        Then the known location of my vehicle should verify this location

    Scenario: Can't localize my vehicle to the same location two times in a row
        And a location
        And my vehicle has been parked into this location
        When I try to park my vehicle at this location
        Then I should be informed that my vehicle is already parked at this location
```

### Definitions:

- **Vehicle**: a car, truck, motocycle, or any transportation mode that can help
  me to move from point A to point B on planet earth.
- **Fleet**: a collection a distinct vehicles.
- **Location**: a way to localize on planet earth, like GPS coordinates
  for example.

#### Guidelines

1. **Don't use any framework at this step!**
2. Prefer **not** using any production dependency
   (therefore, for **javascript**
   [ramda](https://www.npmjs.com/package/ramda) and/or
   [lodash](https://www.npmjs.com/package/lodash) can be used)
3. apply [CQRS & DDD principles](https://martinfowler.com/tags/domain%20driven%20design.html).
4. Write corresponding bdd tests ([behat](https://behat.org/en/latest/),
   [cucumber.js](https://cucumber.io/docs/installation/javascript/), ...)
5. Your code should resides into the following directory structure:

```shell
./src/
   App    # Command, Queries and corresponding handlers
   Domain # Domain model.s/structure.s and value objects
          # (classes or structures & functions if fp)
   Infra  # Implementation of repositories and every specific
          # infrastructure related implementation.s.
```

Note : We use DDD and suggest its use but all modern architectures (Clean architecture, Hexagonal architecture, Port and Adapters, ...) are acceptable


#### Tips

- Try to first write bdd/gherkin tests, then implement the code.
- Ask you: how many entities do I have?
- Ask you: how many Commands? Queries?
- At the moment, you don't have to persist data elsewhere than **in memory**.
- Here's an indication of ≈ expected number of line of codes, for implementations
  in **php** and **javascript**:

## Step 2

I have a vehicle fleet and I want to manage where every vehicle is parked.
This is the second part, we now want to expose our work to the world!

Please wrap the part 1 into a complete application. We want:

1. A command line cli with the following commands:

```shell
./fleet create <userId> # returns fleetId on the standard output
./fleet register-vehicle <fleetId> <vehiclePlateNumber>
./fleet localize-vehicle <fleetId> <vehiclePlateNumber> lat lng [alt]
```

2. To persist fleet and vehicles into a real repository/database.

#### Guidelines

1. Feel free to use helpful framework/libs to manage command line cli
2. Take a look at your **B**ehavior **D**riven **D**evelopment tool (BDD),
   especially profiles and/or suites and/or tags to only switch pertinent tests
   on real infrastructure (with persistence) while keeping not critical
   as they was before.

## Step 3

### For code quality, you can use some tools : which one and why (in a few words) ?

For code quality, I can use some tools like:
- PHPStan focuses on finding errors in your code without actually running it. It catches whole classes of bugs even before you write tests for the code. It moves PHP closer to compiled languages in the sense that the correctness of each line of the code can be checked before you run the actual line.

Commande à exécuter: `vendor/bin/phpstan analyse -c tests/phpstan.neon`
- PHPMD can be seen as an user friendly and easy to configure frontend for the raw metrics measured by PHP Depend. What PHPMD does is: It takes a given PHP source code base and look for several potential problems within that source. These problems can be things like: Possible bugs

Commande à exécuter: `vendor/bin/phpmd src text tests/phpmd.xml`
- Psalm is a free & open-source static analysis tool that helps you identify problems in your code, so you can sleep a little better. Psalm helps people maintain a wide variety of codebases – large and small, ancient and modern.

Commande à exécuter: `vendor/bin/psalm -c tests/psalm.xml`
- PHPCS: PHP Coding Standards with config Symfony / PSR-2 / PSR-12
Commandes pour la config:
```
        vendor/bin/phpcs --config-set installed_paths vendor/escapestudios/symfony2-coding-standard
        vendor/bin/phpcs --config-set colors 1
        vendor/bin/phpcs --config-set severity 1
        vendor/bin/phpcs --config-set warning_severity 6
        vendor/bin/phpcs --config-set report_width 150
        vendor/bin/phpcs --config-set php_version 80106
```
Commande à exécuter: `vendor/bin/phpcs --standard=Symfony --extensions=php config public src`
- ComposerRequireChecker: Verify that no unknown symbols are used in the sources of a package.

Commande à exécuter: `vendor/bin/composer-require-checker check composer.json`

- Behat is an open source Behavior-Driven Development framework for PHP. It is a tool to support you in delivering software that matters through continuous communication, deliberate discovery and test-automation.
(I haven't installed it yet and I haven't written any tests).

- PHPUnit: You can perform unit testing in PHP with PHPUnit, a programmer-oriented testing framework for PHP. PHPUnit is an instance of the xUnit architecture for unit testing frameworks. It is very easy to install and get started with
(I haven't installed it yet and I haven't developed unit tests).


**All the tests described will be used to improve the quality of the code and eliminate as many bugs as possible.**


### You can consider to setup a ci/cd process : describe the necessary actions in a few words

If I were to set up a CI, process steps would be:
- Build an image to run the tests.
- Run the static tests described above (PHPCS, PHPMD, PHPStan, Psalm).
- Run the units tests described (PHPUnit where we get the code coverage).
- Run the functional tests (Behat).
The CI would be launched on each PUSH.

If I were to set up a CD, it necessarily depends on the versioning workflow but for example it could be:
- When a feature branch is merged (with a PR) to a release branch, the deploy script is run to deploy into integration environments (internal recipe).
- When a release branch is merged (with a PR) to the develop branch, the deploy script is run to deploy into recipe environments (customer recipe).
- When the develop branch or hotfix branch is merged (with a PR) to the master branch and a tag is created, the deploy script is run to deploy into production environment.

### Evaluation

- Quality of the code.
- Please be careful to not over engineer your solution!
- Usage of good practices and modern programming language features.

### Init project

- `docker compose up --build -d`
- `docker exec -it php bash` then `composer install` and `bin/console doctrine:migrations:migrate`
- The command can be run into php container now. For example: 
