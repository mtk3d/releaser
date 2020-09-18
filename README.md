# Releaser
This tool will help releasing and CHANGELOG.md maintaining in git projects.

**This CLI is in test phase!**

# Install
```bash
$ composer require mtk/releaser
```

# Usage
Create new change:
```bash
$ vendor/bin/releaser new feature "Example change" "ID-543" "John Doe"
```
Available types:
- fix
- feature
- deprecation
- security
- performance
- other

Create new release:
```bash
$ vendor/bin/releaser release major
```
Available releases:
- major
- minor
- patch

## Example usage scenario
```gherkin
Feature: Create new change by developer
Background: We have git repository on GitLab, and developer with his own branch

Given branch with uncommited changes
When developer make new change
Then new change file is created
```

```gherkin
Feature: Create new release
Background: We have git repository on GitLab, with merged developer's branches to master

Given master branch with unreleased changes
When maintainer release new version
Then changelog file is updated
And new git tag is created
And release is published
```

## Configuration defaults
```yaml
changesDirectory: .unreleased
changelogName: CHANGELOG.md
git:
  enabled: true
  push: true
  commitMessage: Update changelog
publishers: {}
```

## Configure GitLab release
```yaml
publishers:
  class: GitLabPublisherClient
  projectId: 100
  privateToken: DA32HJB2KLH321
  gitlabUrl: https://gitlab.com
```

## TODO
- [ ] Add more publishers, and test custom publisher
- [ ] Refactor functional test for DI container usage
- [ ] Write better docs
- [ ] Add wizard to create change
- [ ] Fix git changes checking