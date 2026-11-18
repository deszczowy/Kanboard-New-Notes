# Notebook, the Kanboard plugin

Keep your notes organized with a dedicated Notebook built into Kanboard. Create notes, add tags, and find what you need quickly. Your notes stay independent of projects and tasks, so useful ideas and information are always easy to keep at hand.

This project is based on [kanboard-notes-plugin](https://gitlab.com/colonelpopcorn/kanboard-notes-plugin) created by Jonathan Ling and released under the MIT License. It is an independent modification that I make to learn how to create plugins for Kanboard, but also to adapt this particular plugin to my own needs. I do not maintain the original plugin.

`Notebook` is a separate plugin, is completely independent from its predecessor and uses its own database structures. But it is still in the joyfull development phase, so **please be careful when using the plugin in your work environment!**

### Installation

The plugin is developed on Kanboard version 1.2.57, but should work properly from version 1.0.35.

Plugin is not accessible from official Kanboard Plugin Directory, so to install it, you can choose one of two methods:

1. Download the zip file and decompress everything under the directory `plugins/Notebook`, or
2. Clone this repository into the folder `plugins/Notebook`

Remember, that plugin folders are case-sensitive.

### Features in development
* Migration tool from previous plugin 
* Dynamic tag creation from edit page
* Search by tag
* Download as a plaintext, markdown or pdf file
